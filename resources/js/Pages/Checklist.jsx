import React, { useState, useMemo } from 'react';
import { Head } from '@inertiajs/react';
import axios from 'axios';

export default function Checklist({ config }) {
    const { categories } = config;
    const [currentStepIndex, setCurrentStepIndex] = useState(0);
    const [responses, setResponses] = useState({});
    const [isSubmitting, setIsSubmitting] = useState(false);

    const currentCategory = categories[currentStepIndex];
    
    // Evaluate conditions for fields
    const visibleFields = useMemo(() => {
        return currentCategory.fields.filter(field => {
            if (!field.condition) return true;
            
            const dependentValue = responses[currentCategory.id]?.[field.condition.field];
            if (!field.condition.operator || field.condition.operator === '==') {
                if (Array.isArray(dependentValue)) {
                    return dependentValue.includes(field.condition.value);
                }
                return dependentValue === field.condition.value;
            }
            if (field.condition.operator === 'includes') {
                return Array.isArray(dependentValue) && dependentValue.includes(field.condition.value);
            }
            if (field.condition.operator === '!=') {
                if (Array.isArray(dependentValue)) {
                    return !dependentValue.includes(field.condition.value);
                }
                return dependentValue !== field.condition.value;
            }
            return false;
        });
    }, [currentCategory, responses]);

    const isStepComplete = useMemo(() => {
        return visibleFields.every(field => {
            if (!field.required) return true;
            const val = responses[currentCategory.id]?.[field.id];
            if (Array.isArray(val)) return val.length > 0;
            return val !== undefined && val !== '';
        });
    }, [visibleFields, responses, currentCategory]);

    const handleInputChange = (fieldId, value) => {
        setResponses(prev => ({
            ...prev,
            [currentCategory.id]: {
                ...prev[currentCategory.id],
                [fieldId]: value
            }
        }));
    };

    const handleNext = () => {
        if (currentStepIndex < categories.length - 1) {
            setCurrentStepIndex(prev => prev + 1);
        } else {
            handleSubmit();
        }
    };

    const handleBack = () => {
        if (currentStepIndex > 0) {
            setCurrentStepIndex(prev => prev - 1);
        }
    };

    const [submitError, setSubmitError] = useState(null);

    const handleSubmit = async () => {
        setIsSubmitting(true);
        setSubmitError(null);
        try {
            const { data } = await axios.post('/api/v1/rooms', { checklist: responses });
            if (data && data.session_id) {
                window.location.href = `/rooms/${data.session_id}`;
            } else {
                throw new Error('Invalid response from server.');
            }
        } catch (error) {
            console.error('Submission failed:', error);
            setSubmitError(error.response?.data?.message || 'Failed to submit room configuration. Please try again.');
            setIsSubmitting(false);
        }
    };

    const progressPercentage = ((currentStepIndex) / categories.length) * 100;

    return (
        <div className="container">
            <Head title="Design Your Space" />
            
            <header className="header">
                <h1 className="title">HavenIQ</h1>
                <p className="subtitle">Design your space, discover yourself.</p>
            </header>

            <div className="glass-card">
                <div className="progress-container">
                    <div 
                        className="progress-fill" 
                        style={{ width: `${progressPercentage}%` }}
                    ></div>
                </div>

                <h2 style={{ fontSize: '1.5rem', marginBottom: '2rem' }}>
                    {currentCategory.title}
                </h2>

                <div className="fields-container">
                    {visibleFields.map((field) => (
                        <div key={field.id} className="field-group">
                            <label className="field-label">{field.label}</label>
                            
                            {field.type === 'radio' && (
                                <div className="radio-group">
                                    {field.options.map(option => (
                                        <label key={option} className="radio-option">
                                            <input 
                                                type="radio"
                                                name={field.id}
                                                value={option}
                                                checked={responses[currentCategory.id]?.[field.id] === option}
                                                onChange={(e) => handleInputChange(field.id, e.target.value)}
                                            />
                                            <div className="radio-content">
                                                {option}
                                            </div>
                                        </label>
                                    ))}
                                </div>
                            )}

                            {field.type === 'checkbox' && (
                                <div className="radio-group">
                                    {field.options.map(option => {
                                        const currentVal = responses[currentCategory.id]?.[field.id] || [];
                                        const isChecked = Array.isArray(currentVal) 
                                            ? currentVal.includes(option) 
                                            : currentVal === option;
                                        return (
                                            <label key={option} className="radio-option">
                                                <input 
                                                    type="checkbox"
                                                    name={field.id}
                                                    value={option}
                                                    checked={isChecked}
                                                    onChange={(e) => {
                                                        const prev = responses[currentCategory.id]?.[field.id] || [];
                                                        const prevArr = Array.isArray(prev) ? prev : (prev ? [prev] : []);
                                                        const nextArr = e.target.checked 
                                                            ? [...prevArr, option] 
                                                            : prevArr.filter(v => v !== option);
                                                        handleInputChange(field.id, nextArr);
                                                    }}
                                                />
                                                <div className="radio-content">
                                                    {option}
                                                </div>
                                            </label>
                                        );
                                    })}
                                </div>
                            )}

                            {field.type === 'text' && (
                                <input
                                    type="text"
                                    className="text-input"
                                    placeholder={field.placeholder || ''}
                                    value={responses[currentCategory.id]?.[field.id] || ''}
                                    onChange={(e) => handleInputChange(field.id, e.target.value)}
                                />
                            )}
                        </div>
                    ))}
                </div>

                {submitError && (
                    <div style={{ padding: '1rem', marginTop: '1.5rem', background: 'rgba(239, 68, 68, 0.15)', border: '1px solid var(--error-color)', borderRadius: '12px', color: '#FCA5A5', fontSize: '0.95rem', textAlign: 'center' }}>
                        {submitError}
                    </div>
                )}

                <div className="btn-group">
                    <button 
                        className="btn btn-secondary"
                        onClick={handleBack}
                        disabled={currentStepIndex === 0 || isSubmitting}
                    >
                        Back
                    </button>
                    <button 
                        className="btn btn-primary"
                        onClick={handleNext}
                        disabled={!isStepComplete || isSubmitting}
                    >
                        {isSubmitting ? 'Generating...' : (currentStepIndex === categories.length - 1 ? 'Generate My Space' : 'Next Step')}
                    </button>
                </div>
            </div>
        </div>
    );
}
